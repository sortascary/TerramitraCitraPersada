import gsap from "gsap";
import ScrollTrigger from "gsap/src/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

gsap.utils.toArray(".frame").forEach(frame => {
  gsap.from(frame, {
    y: -10,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: frame,
      toggleActions: "play pause resume reset"
    }
  });
});

gsap.from("#bg", {
    scrollTrigger: {
        trigger: "#bg",
        start:"bottom 80%",
        end:"bottom 30%",
        scrub:true,
        pin:true
    }
});