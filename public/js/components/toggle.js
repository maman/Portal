const init = document => {
  $('[data-toggle]').on('click', evt => {
    evt.preventDefault();
    const [target, className] = $(evt.currentTarget).data('toggle').split(':');
    $(`[data-toggle-target="${target}"]`).toggleClass(className);
  });
};

export default {
  init,
};
