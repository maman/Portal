import '../less/main.less';

import toggle from './components/toggle';
import sticky from './components/sticky';
import tab from './components/tab';

$(document).ready(() => {
  toggle.init(document);
  sticky.init(document);
  tab.init(document);
});
