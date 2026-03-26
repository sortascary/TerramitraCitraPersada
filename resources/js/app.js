import './bootstrap';

import gsap from "gsap";
import ScrollTrigger from "gsap/src/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

gsap.utils.toArray(".fromRight").forEach(frame => {
  gsap.from(frame, {
    x: 50,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: frame,
      toggleActions: "play pause resume reset"
    }
  });
});
gsap.utils.toArray(".fromLeft").forEach(frame => {
  gsap.from(frame, {
    x: -50,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: frame,
      toggleActions: "play pause resume reset"
    }
  });
});

