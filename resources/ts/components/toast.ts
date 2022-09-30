import Toastify from 'toastify-js'

export default class Toast {
    static toastType: object = {
        "error": "#ee210a",
        "success": "#48db13",
        "info": "#14d5c6"}
    public static showToast(text: string, type: string = "error"): void
    {
        Toastify({
            text: text,
            style: {
                background: Toast.toastType[type],
            },
        }).showToast();
    }
}
