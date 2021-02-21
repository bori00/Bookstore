class Dialog {
    static show(title, content) {
        const dialog = new mdc.dialog.MDCDialog(document.getElementById("my-dialog"));
        document.getElementById("my-dialog-title").innerText = title;
        document.getElementById("my-dialog-content").innerText = content;
        dialog.open();
    }
}