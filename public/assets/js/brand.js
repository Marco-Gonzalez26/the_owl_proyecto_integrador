export function addBrandSize() {
  const container = document.getElementById('sizesContainer')

  const div = document.createElement('div')
  div.className = 'input-group mb-2'
  div.innerHTML = `
      <input type="text" name="brandSizes[]" class="form-control" placeholder="Ej: 500ml" required>
      <button type="button" class="btn btn-outline-danger remove-size"><i class="bi bi-x" onclick="removeBrandSize(event)"></i></button>
    `
  container.appendChild(div)
}

export function removeBrandSize(e) {
  if (e.target.classList.contains('remove-size')) {
    e.target.closest('.input-group').remove()
  }
}

window.addBrandSize = addBrandSize
window.removeBrandSize = removeBrandSize
