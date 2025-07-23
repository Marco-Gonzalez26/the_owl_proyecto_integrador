import {
  deleteFromCart,
  updateCart,
  addToCart,
  loadCart,
  updateQuantity,
  toggleCart
} from './cart.js'
import { showToast } from './toast.js'

import { addBrandSize, removeBrandSize } from './brand.js'

document.addEventListener('DOMContentLoaded', () => {
  loadCart()

  document.getElementById('cart-btn').addEventListener('click', () => {
    toggleCart()
  })

  document.getElementById('add-to-cart-btn').addEventListener('click', () => {
    addToCart()
      .then(() => {
        showToast('Operacion exitosa', 'Se ha añadido el producto a tu carrito')
      })
      .catch((error) => {
        showToast(
          'Error',
          'Ocurrió un error al añadir el producto a tu carrito',
          'danger'
        )
      })
  })
})
