import { state } from './state.js'
import { showToast } from './toast.js'
export function deleteFromCart(id) {
  const productToDelete = state.cart.items.find(
    (item) => item.productId === id + ''
  )
  state.cart.items = state.cart.items.filter((item) => item.productId !== id)
  state.cart.total -= productToDelete.price * productToDelete.quantity
  updateCart()
}

export async function loadCart() {
  try {
    let cart
    const response = await fetch('/apps/theowl/public/cart', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    })
    if (localStorage.getItem('cart')) {
      cart = JSON.parse(localStorage.getItem('cart'))
    } else {
      cart = await response.json()
    }
    state.cart = cart
    updateCart()
  } catch (error) {
    console.log(error.message)
  }
}

export function updateCart() {
  const cartItemsContainer = document.getElementById('cart-items-container')
  const buyBtn = document.getElementById('buy-btn')
  cartItemsContainer.innerHTML = ''

  if (state.cart.items.length === 0) {
    cartItemsContainer.innerHTML = '<h4>Tu carrito está vacío</h4>'
    buyBtn.innerHTML = '<i class="bi bi-cart-x"></i> Añade productos al carrito'
    buyBtn.disabled = true
    return
  }
  buyBtn.innerHTML = '<i class="bi bi-cart"></i> Completar compra'
  buyBtn.disabled = false
  state.cart.items.forEach((item) => {
    const itemElement = document.createElement('div')
    itemElement.innerHTML = `
                <div class="product-card p-3 shadow-sm bg-white" data-product-id="${item.productId}">
                    <div class="row align-items-center justify-content-center gap-3 position-relative">
                        <div class="col-md-1 position-absolute top-0 end-0" id="remove-from-cart-btn" onclick="deleteFromCart(${item.productId})">
                            <i class="bi bi-trash remove-btn"></i>
                        </div>
                        <div class="col-md-2">
                            <img src="${item.imageUrl}" alt="${item.name}" class="product-image">
                        </div>
                        <div class="col-md-3">
                            <h6 class="mb-1">${item.name}</h6>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                <button class="quantity-btn btn" onclick="updateQuantity(${item.productId}, -1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="quantity-input" value="${item.quantity}" min="1">
                                <button class="quantity-btn btn">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span class="fw-bold">${item.price}</span>
                        </div>
                    </div>
                </div>
            `
    cartItemsContainer.appendChild(itemElement)
  })

  // Update summary
  document.getElementById('items-qty').innerHTML = `
            ${state.cart.items.length} producto${
    state.cart.items.length !== 1 ? 's' : ''
  }
        `
  document.getElementById(
    'cart-total'
  ).innerHTML = `Total: ${state.cart.total}$`

  saveCart()
}
export async function saveCart() {
  const cartToSave = state.cart
  try {
    await fetch('/apps/theowl/public/cart/save', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        cart: JSON.stringify(cartToSave)
      })
    })

    localStorage.setItem('cart', JSON.stringify(cartToSave))
  } catch (error) {
    console.log('Save cart ', error.message)
  }
}

export function updateQuantity(id, value) {
  const quantity = document.getElementById('quantity')
  state.cart.items.forEach((item) => {
    if (item.productId === id) {
      item.quantity += value
      quantity.value = item.quantity
      updateCart()
    }
  })
}

export function toggleCart() {
  const cartWrapper = document.getElementById('cart-wrapper')
  const cartBtn = document.getElementById('cart-btn')

  if (!state.cartIsOpen) {
    cartWrapper.classList.toggle('show')
    cartBtn.innerHTML = '<i class="bi bi-x"></i>'
    state.cartIsOpen = true
  } else {
    cartWrapper.classList.toggle('show')
    cartBtn.innerHTML = '<i class="bi bi-cart"></i>'
    state.cartIsOpen = false
  }
}

export async function addToCart() {
  const productId = document.getElementById('productId').value
  const name = document.getElementById('name').value
  const price = document.getElementById('price').value
  const quantity = document.getElementById('quantity').value
  const imageUrl = document.getElementById('imageUrl').value

  try {
    await fetch('/apps/theowl/public/cart/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        product_id: productId,
        name,
        price,
        quantity,
        image_url: imageUrl
      })
    })

    state.cart.items.push({
      productId,
      name,
      price,
      quantity,
      imageUrl
    })
    state.cart.total = state.cart.total + price * quantity
    updateCart()
    showToast('Operacion exitosa', 'Se ha añadido el producto a tu carrito')
  } catch (error) {
    console.log('Add to cart ', error.message)
    showToast(
      'Error',
      'Ocurrió un error al añadir el producto a tu carrito',
      'danger'
    )
  }
}

function cleanCart() {
  localStorage.removeItem('cart')
  state.cart = {
    items: [],
    total: 0
  }

  updateCart()
}

window.addToCart = addToCart
window.deleteFromCart = deleteFromCart
window.updateQuantity = updateQuantity
window.toggleCart = toggleCart
window.cleanCart = cleanCart
