<?php
/****************************************************************************** */
                    // PHP CODE SECTION
/****************************************************************************** */

session_start(); 
require("functions.php");

$funcObj = new dbFunction();     // Instantiate - Creating an instance or object of a class

// initial speed is set to zero, when the arrow keys are pressed,
// the speed is queried from the database.
$speed = 0;

// returns the speed with which the object has to move 
function getSpeed($id){
    global $funcObj;
    $fetchSpeed = $funcObj->FetchSpeed($id);        
    $value = 0;
    foreach($fetchSpeed as $row){
        $value = $row["value"];
    }
    return $value;
}


// inserts the record in the database
function addRecord(){
    global $funcObj;
    $timetaken = 0;
    if(isset($_COOKIE["timeTaken"])) {
        $timetaken = $_COOKIE["timeTaken"];
    }
    $addRecord = $funcObj->SucessRegister(session_id(), $timetaken);
    if($addRecord){
        return "Record added.";
    }
    // setcookie("timeTaken", 0);
    return "Failed to add record";
}

/****************************************************************************** */
                    // PHP CODE SECTION ENDS
/****************************************************************************** */

?>

<!DOCTYPE html>

<html>
	<head>
		<title>Moving marker</title>
		<!-- META INFORMATION -->

		<meta charset="UTF-8" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<meta name="description" content="Moving marker with Leaflet" />
		<meta
			name="keywords"
			content="Moving marker with Leaflet from Roshan Prtap Katel"
		/>

		<!-- CSS -->
		<link
			rel="stylesheet"
			href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"
		/>

		<link rel="stylesheet" href="style.css" />
	</head>

	<body>
		<main>
			<section>
				<div id="map"></div>
			</section>
		</main>

		<script
			type="text/javascript"
			src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"
		></script>
		<script src="https://npmcdn.com/leaflet-geometryutil"></script>
		<script type="text/javascript" src="./MovingMarker.js"></script>
		<script>
            /****************************************************************************** */
                    // JAVASCRIPT CODE SECTION
            /****************************************************************************** */


            document.cookie = "timeTaken" + "=" + 0 + ";";

            // initialize the map on the "map" div with a given center and zoom
            var map = new L.Map("map", {
                zoom: 6,
                minZoom: 3,
            });
            // create a new tile layer
            var tileUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                layer = new L.TileLayer(tileUrl, {
                    attribution:
                        'Maps © <a href="www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18,
                });
            // add the layer to the map
            map.addLayer(layer);
            
            var NorreportNaestvedLL = [
                [55.6837, 12.5716],
                [55.232816, 11.76713],
            ];

            map.fitBounds(NorreportNaestvedLL);

            /****************************************************************************** */
            //= GLOBAL DURATION CALCULATOR

            var speed = <?php echo(json_encode(getSpeed("1"))); ?>; // speed in km per hour
            var TotalDistance = 71.396; // distance in km
            var durationInHour = TotalDistance / speed;
            var durationInMs = durationInHour * 60 * 60 * 1000;
            /****************************************************************************** */
            // defining the custom icon
            var icon_tomato = L.icon({
                    iconUrl: './images/tomato.gif',
                    iconSize:     [90, 90], // size of the icon
                });
            // adding circle to the the destination - Naestved
            var destination = L.circle([55.232816,11.767130], 900, {
                color: "red",
            }).addTo(map);

            // Moving icon
            var myMovingMarker = L.Marker.movingMarker(
                [[55.6837, 12.5716]],
                durationInMs,
                {icon: icon_tomato}
            ).addTo(map).bindPopup("Use arrow key to move me and spacebar to double my speed.");;

            /*******************************************************************/
            // HANDLING THE KEYBOARD EVENTS
            var radiusInKm = 100;
            var angleInDegrees = 0;
            var allowedKeyName = ["ArrowUp", "ArrowRight", "ArrowDown", "ArrowLeft"]; // only these key moves the marker

            // WHEN THE KEY IS PRESSED
            document.addEventListener(
                "keydown",
                (event) => {
                    const keyName = event.key;
                    if(event.key === 32){       // key: 32 is for space bar
                         // fetch the new speed here 
                        speed = <?php echo(json_encode(getSpeed("2"))); ?>;    
                        durationInHour = TotalDistance / speed;
                        durationInMs = durationInHour * 60 * 60 * 1000;
                        // performs  the operation only if the arrow keys are pressed.
                        if (allowedKeyName.includes(keyName)) {
                            // function to give direction of move
                            computeAngle(keyName);      
                            var to = L.GeometryUtil.destination(
                                myMovingMarker.getLatLng(),
                                angleInDegrees,
                                radiusInKm * 1000
                            );
                             // moves the object towards the desired direction
                            myMovingMarker.moveTo([to.lat, to.lng], durationInMs);     
                        }
                    }
                    if (allowedKeyName.includes(keyName)) {
                        // function to give direction of move
                        computeAngle(keyName);
                        var to = L.GeometryUtil.destination(
                            myMovingMarker.getLatLng(),
                            angleInDegrees,
                            radiusInKm * 1000
                        );
                         // moves the object towards the desired direction
                        myMovingMarker.moveTo([to.lat, to.lng], durationInMs);
                    } else {
                        // do nothing for other keys
                        console.log("the key pressed is", keyName);
                    }
                },
                false
            );

            // WHEN THE KEY IS RELEASED
            document.addEventListener(
                "keyup",
                (event) => {
                    const keyName = event.key;
                    if (allowedKeyName.includes(keyName)) {
                        // stops the object from moving when the key is released
                        myMovingMarker.stop();
                        var distanceFromDestination = computeDistance();
                        // perfom the operation of sucess when the object is within 1km radius of desination
                        if (distanceFromDestination < 1) {
                            stopCounter();
                            document.cookie = "timeTaken" + "=" + cnt + ";";
                            // insert details in the database about the user activity here
                            var result = <?php echo(json_encode(addRecord())); ?>;
                            // ALSO STOP THE  TIMER
                            // .................

                            alert(
                                "Congratulation! you arrived in the destination in."+ cnt+ " second. "+result +" The game will restart now."
                            );
                            // reloads the window after 1 second
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 1000)
                            myMovingMarker.moveTo([55.6837, 12.5716], 5000);
                        }
                        else {
                            // do nothing
                        }
                    }
                },
                false
            );
            /*******************************************************************/

            /******************************************************************* */
            //= Distance calculator
            function computeDistance() {
                var from = myMovingMarker.getLatLng();
                var to = destination.getLatLng();
                let dis = from.distanceTo(to).toFixed(0) / 1000;
                return dis;
            }
            /******************************************************************* */

            /******************************************************************* */
            //= Angle calculator

            function computeAngle(keyName) {
                counter();
                if (keyName === "ArrowUp") {
                    angleInDegrees = 360;
                }
                if (keyName === "ArrowRight") {
                    angleInDegrees = 90;
                }
                if (keyName === "ArrowDown") {
                    angleInDegrees = 180;
                }
                if (keyName === "ArrowLeft") {
                    angleInDegrees = 270;
                }
            }
            /******************************************************************* */

            /******************************************************************* */
            //= Timer to track the user play time
            var check = null;
            var cnt = 0;

            function counter() {
                if (check == null) {
                    check = setInterval(function () {
                        cnt += 1;
                    }, 1000);
                }
            }

            function stopCounter() {
                clearInterval(check);
                check = null;
            }

            /****************************************************************************** */
                    // JAVASCRIPT CODE SECTION ENDS
            /****************************************************************************** */

        </script>
	</body>
</html>
