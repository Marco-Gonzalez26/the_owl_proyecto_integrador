export function showToast(title, message, type = 'success') {
  const toastEl = document.getElementById('liveToast')
  document.getElementById('toast-title').textContent = title
  document.getElementById('toast-message').textContent = message
  new bootstrap.Toast(toastEl).show()
}
