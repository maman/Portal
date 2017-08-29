const init = document => {
  $('[data-tab-action]').on('click', evt => {
    evt.preventDefault();
    const currentEl = $(evt.currentTarget);
    const target = currentEl.data('tab-action');
    const targetEl = $(`[data-tab-target=${target}]`);
    const parentEls = currentEl.parent('.tab-item').siblings('.tab-item');
    const parentEl = currentEl.parent('.tab-item');

    parentEls.removeClass('active');
    parentEl.addClass('active');

    console.log(target, targetEl, targetEl.siblings());

    targetEl.siblings('[data-tab-target]').addClass('d-none');
    targetEl.removeClass('d-none');
  });
};

export default {
  init,
};
