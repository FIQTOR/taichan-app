
function copyText(value) {
  copyText = value;
  // Select the text field
  // copyText.select();
  // copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText);

  alert('Berhasil di salin!');
}