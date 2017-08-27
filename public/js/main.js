import '../less/main.less';

import toggle from './components/toggle';
import sticky from './components/sticky';

$(document).ready(() => {
  toggle.init(document);
  sticky.init(document);
});
