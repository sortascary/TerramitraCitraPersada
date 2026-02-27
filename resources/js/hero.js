import * as THREE from 'three';


// Scene
const scene = new THREE.Scene();
const stars = new THREE.TextureLoader().load('images/2k_stars.jpg');
scene.background = stars;

// Camera
const camera = new THREE.PerspectiveCamera(
    75,
    window.innerWidth / (window.innerHeight * 9 /10),
    0.1,
    1000
);
camera.position.z = 3;
camera.position.x = -2;

// Renderer
const renderer = new THREE.WebGLRenderer({
  canvas: document.querySelector('#bg'),
});
renderer.setSize(window.innerWidth, window.innerHeight * 9 / 10);

// Sphere
const geometry = new THREE.SphereGeometry(1, 32, 32);

const earthtexture = new THREE.TextureLoader().load('images/Earth.jpg');
const normaltexture = new THREE.TextureLoader().load('images/normals.jpg');
const material = new THREE.MeshStandardMaterial({
    map: earthtexture,
    normalMap: normaltexture,
});
const sphere = new THREE.Mesh(geometry, material);
sphere.rotation.z = -0.2;
scene.add(sphere);

// Light
const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(5, 5, 5);
scene.add(light);

// Animate
function animate() {
    requestAnimationFrame(animate);
    sphere.rotateY(0.005);
    renderer.render(scene, camera);
}
animate();

// Resize
window.addEventListener('resize', () => {
    const width = window.innerWidth;
    const height =(window.innerHeight * 9 / 10);

    camera.aspect = width / height;
    camera.updateProjectionMatrix();

    renderer.setSize(width, height, false);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    camera.position.x = width < 900? 0 : -2;
});