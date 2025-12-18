require(['../../../node_modules/@material/menu'], mdcMenu => {
    const MDCMenu = mdcMenu.MDCMenu;
});

const menu = new MDCMenu(document.querySelector('.mdc-menu'));
menu.open = true;