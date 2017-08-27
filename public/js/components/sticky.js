import 'waypoints/jquery.waypoints';
import 'waypoints/shortcuts/sticky';

const init = document => {
  const sticky = new Waypoint.Sticky({
    element: document.querySelector('[data-sticky]'),
    stuckClass: 'stick',
  });
};

export default {
  init,
};
