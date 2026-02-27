import gsap from "gsap";
import ScrollTrigger from "gsap/src/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

gsap.to("#bg", {
    scrollTrigger: {
        trigger: "#bg",
        start:"bottom 80%",
        end:"bottom 30%",
        scrub:true,
        pin:true
    }
});

window.addEventListener("resize", () => {
  ScrollTrigger.refresh();
});

window.addEventListener("load", () => {
  ScrollTrigger.refresh();
});
