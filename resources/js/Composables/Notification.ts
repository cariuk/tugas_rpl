import Swal from 'sweetalert2';

export function showNotification(title: string, text: string, type: string = 'success') {
    new Swal(text);
}
