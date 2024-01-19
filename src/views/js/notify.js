// let btn2 = document.getElementById('generateToastButton');
//
// btn2.addEventListener('click', ()=>{
//     ShowNotify('ehhehehe', 'work');
// })
function ShowNotify(header, text, type ="primary" ) {

        let notificationSound = document.getElementById("notificationSound");
        let toastElement = document.createElement("div");
        toastElement.classList.add("toast");
        toastElement.setAttribute("role", "alert");
        toastElement.setAttribute("aria-live", "assertive");
        toastElement.setAttribute("aria-atomic", "true");
        toastElement.innerHTML = `
  <div class="toast-header bg-${type}">
    <strong class="me-auto">${header}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    ${text}
  </div>
`;
        document.getElementById("toast-container").appendChild(toastElement);

        let toast = new bootstrap.Toast(toastElement);
        toast.show();

}

