var confirm = document.getElementById('btncancel');

confirm.addEventListener('click', btnConfirm);

function btnConfirm() {
  let confirm = confirm("Are you sure you want to cancel?");
  if (confirm == true) {
    window.location.href='index.php';
  }
  // else {
  //   window.location.href='admin_update.php';
  // }
}
