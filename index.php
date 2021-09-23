<!DOCTYPE html>
<html lang="en">

<head>
    <title>three.js webgl - OBJLoader + MTLLoader</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/main.css">

    <script type="application/javascript" src="js/jquery.min.js"></script>
    <script type="application/javascript" src="js/three.min.js"></script>
    <script type='text/javascript' src='js/OrbitControls.js'></script>
    <script type='text/javascript' src='js/tween.min.js'></script>
    <script type="application/javascript" src="js/MTLLoader.js"></script>
    <script type="application/javascript" src="js/DDSLoader.js"></script>
    <script type="application/javascript" src="js/GLTFLoader.js"></script>
</head>

<body>
    <div class="setting_trigger">Configure your Sofa</div>
    <div class="confi_wrap">
        <div class="changer_wrap base_wrap">
            <a href="javascript:void(0);">BASE</a>
            <ul>
                <li><a href="javascript:void(0);" forr="base" imgname="darkorangeleather">Dark Orange</a></li>
                <li><a href="javascript:void(0);" forr="base" imgname="kakkyleather">Kakky</a></li>
                <li><a href="javascript:void(0);" forr="base" imgname="orangeleather">Orange</a></li>
                <li><a href="javascript:void(0);" forr="base" imgname="pink">Pink</a></li>
                <li><a href="javascript:void(0);" forr="base" imgname="white">White</a></li>
            </ul>
        </div>
        <div class="changer_wrap base_wrap">
            <a href="javascript:void(0);">BOTTOM</a>
            <ul>
                <li><a href="javascript:void(0);" forr="bottom" imgname="darkorangeleather">Dark Orange</a></li>
                <li><a href="javascript:void(0);" forr="bottom" imgname="kakkyleather">Kakky</a></li>
                <li><a href="javascript:void(0);" forr="bottom" imgname="orangeleather">Orange</a></li>
                <li><a href="javascript:void(0);" forr="bottom" imgname="pink">Pink</a></li>
                <li><a href="javascript:void(0);" forr="bottom" imgname="white">White</a></li>
            </ul>
        </div>
        <div class="changer_wrap base_wrap">
            <a href="javascript:void(0);">BACK</a>
            <ul>
                <li><a href="javascript:void(0);" forr="back" imgname="darkorangeleather">Dark Orange</a></li>
                <li><a href="javascript:void(0);" forr="back" imgname="kakkyleather">Kakky</a></li>
                <li><a href="javascript:void(0);" forr="back" imgname="orangeleather">Orange</a></li>
                <li><a href="javascript:void(0);" forr="back" imgname="pink">Pink</a></li>
                <li><a href="javascript:void(0);" forr="back" imgname="white">White</a></li>
            </ul>
        </div>
    </div>
    <script type="x-shader/x-vertex" id="vertexShader">

        varying vec3 vWorldPosition;

			void main() {

				vec4 worldPosition = modelMatrix * vec4( position, 1.0 );
				vWorldPosition = worldPosition.xyz;

				gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );

			}

		</script>
    <script type="x-shader/x-fragment" id="fragmentShader">

        uniform vec3 topColor;
			uniform vec3 bottomColor;
			uniform float offset;
			uniform float exponent;

			varying vec3 vWorldPosition;

			void main() {

				float h = normalize( vWorldPosition + offset ).y;
				gl_FragColor = vec4( mix( bottomColor, topColor, max( pow( max( h , 0.0), exponent ), 0.0 ) ), 1.0 );

			}

		</script>
    <script type="module">
        (function($){
//			import * as THREE from 'js/three.min.js';

//			import { DDSLoader } from '/js/DDSLoader.js';
//			import { MTLLoader } from '/js/MTLLoader.js';
//			import { OBJLoader } from '/js/OBJLoader.js';

			var container, controls, bottomobj, baseobj, backobj, dirLight, dirLightHeper, hemiLight, hemiLightHelper;

			var camera, scene, renderer;

			var mouseX = 0, mouseY = 0;

			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
            
            var imggloader = new THREE.ImageLoader( manager );
            var basetexture = new THREE.Texture();
            var bottomtexture = new THREE.Texture();
            var backtexture = new THREE.Texture();
            var manager = new THREE.LoadingManager();

			init();
			animate();


			function init() {

				container = document.createElement( 'div' );
				document.body.appendChild( container );

				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
//				camera.position.z = 50;
				camera.position.z = 20;
//                camera.position.x = 0;
                camera.position.x = -20;
//                camera.position.y = 160;
                camera.position.y = 65;
                
				camera.rotation.z = 0;
                camera.rotation.x = 0;
                camera.rotation.y = 0;

				// scene

				scene = new THREE.Scene();
				scene.add( camera );
                
                scene.background = new THREE.Color().setHSL( 0.6, 0, 1 );
				scene.fog = new THREE.Fog( scene.background, 1, 5000 );

				// LIGHTS

				hemiLight = new THREE.HemisphereLight( 0xffffff, 0xffffff, 0.5 );
				hemiLight.position.set( 0, 100, 0 );
				scene.add( hemiLight );

//				dirLight = new THREE.DirectionalLight( 0xffffff, 0.5 );
//				dirLight.color.setHSL( 0.1, 1, 0.95 );
//				dirLight.position.set( - 1, 1.75, 1 );
//				dirLight.position.multiplyScalar( 10 );
//				scene.add( dirLight );

//				dirLight = new THREE.DirectionalLight( 0xffffff, 1 );
//				dirLight.color.setHSL( 0.1, 1, 0.95 );
//				dirLight.position.set( - 1, 50, 1 );
//				dirLight.position.multiplyScalar( 50 );
//				scene.add( dirLight );

//				dirLight.castShadow = true;

//				dirLight.shadow.mapSize.width = 2048;
//				dirLight.shadow.mapSize.height = 2048;

//				var d = 50;

//				dirLight.shadow.camera.left = - d;
//				dirLight.shadow.camera.right = d;
//				dirLight.shadow.camera.top = d;
//				dirLight.shadow.camera.bottom = - d;

//				dirLight.shadow.camera.far = 3500;
//				dirLight.shadow.bias = - 0.0001;

				var vertexShader = document.getElementById( 'vertexShader' ).textContent;
				var fragmentShader = document.getElementById( 'fragmentShader' ).textContent;
				var uniforms = {
					"topColor": { value: new THREE.Color( 0x0077ff ) },
					"bottomColor": { value: new THREE.Color( 0xffffff ) },
					"offset": { value: 33 },
					"exponent": { value: 0.6 }
				};
//				uniforms[ "topColor" ].value.copy( hemiLight.color );

//				scene.fog.color.copy( uniforms[ "bottomColor" ].value );

				
                
                
                

				// model

				var onProgress = function ( xhr ) {

					if ( xhr.lengthComputable ) {

						var percentComplete = xhr.loaded / xhr.total * 100;

					}

				};

				var onError = function () { };

//				THREE.Loader.Handlers.add( /\.dds$/i, new DDSLoader() );
                var mtlLoader = new THREE.MTLLoader();
                
                
                var loader = new THREE.GLTFLoader().setPath( '3dobj/' );
//						loader.load( '570_Dunsmuir_etaj2.glb', function ( gltf ) {
						loader.load( 'Floor plan 24.glb', function ( gltf ) {
//                            gltf.scene.position.x = -10;
//                            gltf.scene.position.y = 5;
//                            gltf.scene.position.z = -4.5;
                            gltf.scene.position.x = -10;
                            gltf.scene.position.y = -90;
                            gltf.scene.position.z = -4;
//                            gltf.scene.rotation.x = 0.1;
							scene.add( gltf.scene );
                            console.log(gltf.scene.position);
                            camera.lookAt( gltf.scene.position );
//                            fitCameraToObject(camera, gltf.scene);
						} );

				renderer = new THREE.WebGLRenderer({preserveDrawingBuffer:true,alpha: true,antialias:true, autoSize: true});
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				container.appendChild( renderer.domElement );
                renderer.gammaInput = true;
				renderer.gammaOutput = true;
				renderer.shadowMap.enabled = true;
                controls = new THREE.OrbitControls( camera, renderer.domElement );
                controls.target.set( 0, 0, 0 );
                controls.autoRotate = true;
				window.addEventListener( 'resize', onWindowResize, false );

			}
            
            
            
            
            function fitCameraToObject( camera, object, offset, controls ) {
var cameraZ = camera;
	offset = offset || 1.25;

	const boundingBox = new THREE.Box3();

	// get bounding box of object - this will be used to setup controls and camera
	boundingBox.setFromObject( object );
        
            //ERRORS HERE
	const center = boundingBox.getCenter();
	const size = boundingBox.getSize();

	// get the max side of the bounding box (fits to width OR height as needed )
	const maxDim = Math.max( size.x, size.y, size.z );
	const fov = camera.fov * ( Math.PI / 180 );
	cameraZ = Math.abs( maxDim / 2 * Math.tan( fov * 2 ) ); //Applied fifonik correction

	cameraZ *= offset; // zoom out a little so that objects don't fill the screen

	// <--- NEW CODE
	//Method 1 to get object's world position
	scene.updateMatrixWorld(); //Update world positions
	var objectWorldPosition = new THREE.Vector3();
	objectWorldPosition.setFromMatrixPosition( object.matrixWorld );
	
	//Method 2 to get object's world position
	//objectWorldPosition = object.getWorldPosition();

	const directionVector = camera.position.sub(objectWorldPosition); 	//Get vector from camera to object
	const unitDirectionVector = directionVector.normalize(); // Convert to unit vector
	camera.position = unitDirectionVector.multiplyScalar(cameraZ); //Multiply unit vector times cameraZ distance
	camera.lookAt(objectWorldPosition); //Look at object
	// --->

	const minZ = boundingBox.min.z;
	const cameraToFarEdge = ( minZ < 0 ) ? -minZ + cameraZ : cameraZ - minZ;

	camera.far = cameraToFarEdge * 3;
	camera.updateProjectionMatrix();

	if ( controls ) {

	  // set camera to rotate around center of loaded object
	  controls.target = center;

	  // prevent camera from zooming out far enough to create far plane cutoff
	  controls.maxDistance = cameraToFarEdge * 2;
             // ERROR HERE	
	  controls.saveState();

	} else {

		camera.lookAt( center )

   }
}
            
            
            
            var color = 0xFFFFFF;
            var intensity = 0.4;
            var light = new THREE.DirectionalLight(color, intensity);
            light.position.set(0, 100, 0);
            light.target.position.set(0, 0, 0);
            scene.add(light);
            scene.add(light.target);
            
            
           /* var light = new THREE.DirectionalLight(color, intensity);
            light.position.set(0, -100, 0);
            light.target.position.set(0, 0, 0);
            scene.add(light);
            scene.add(light.target);
            
            
            var light = new THREE.DirectionalLight(color, intensity);
            light.position.set(100, -100, 0);
            light.target.position.set(0, 0, 0);
            scene.add(light);
            scene.add(light.target);
            
            
            var light = new THREE.DirectionalLight(color, intensity);
            light.position.set(-100, -100, 0);
            light.target.position.set(0, 0, 0);
            scene.add(light);
            scene.add(light.target);*/

			function onWindowResize() {
				windowHalfX = window.innerWidth / 2;
				windowHalfY = window.innerHeight / 2;
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				renderer.setSize( window.innerWidth, window.innerHeight );
			}

			function animate() {
                controls.update();
				requestAnimationFrame( animate );
				render();
			}

			function render() {
				camera.lookAt( scene.position );
				renderer.render( scene, camera );
			}
            })(jQuery)

		</script>

</body>

</html>
