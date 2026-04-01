import type { CartItem } from "../types";

export const cart: CartItem[] = [
  {
    id: 1,
    size: "XS",
    quantity: 3,
    product: {
      id: 1,
      name: "Women Ivory Cotton Silk V Neck A line Kurta, Slip & Salwar",
      slug: "Women-Ivory-Cotton-Silk-V-Neck-A-line-Kurta-Slip-Salwar",
      brand: "Unknown",
      images: [
        {
          url: "http://192.168.0.108:8000/storage/products/1758429115_68cf7fbba6b51.jpg",
          isDefault: 1,
        },
        {
          url: "http://192.168.0.108:8000/storage/products/1758429115_68cf7fbbab797.webp",
          isDefault: 0,
        },
        {
          url: "http://192.168.0.108:8000/storage/products/1758429115_68cf7fbbadb23.jpg",
          isDefault: 0,
        },
      ],
      sizes: [
        { size: "XS", quantity: 10 },
        { size: "S", quantity: 2 },
        { size: "M", quantity: 6 },
        { size: "XL", quantity: 11 },
      ],
      price: {
        sellingPrice: 12990,
        originalPrice: 15000,
        discountPercent: 10,
      },
    },
  },
  {
    id: 2,
    size: "FREE",
    quantity: 1,
    product: {
      id: 5,
      name: "Women saree",
      slug: "women-saree",
      brand: "Unknown",
      images: [
        {
          url: "http://192.168.0.108:8000/storage/products/Women saree_1759926364_68e6585c4cd68.webp",
          isDefault: 1,
        },
        {
          url: "http://192.168.0.108:8000/storage/products/Women saree_1759926365_68e6585d0c481.jpg",
          isDefault: 0,
        },
        {
          url: "http://192.168.0.108:8000/storage/products/Women saree_1759926365_68e6585d0d0be.webp",
          isDefault: 0,
        },
      ],
      sizes: [
        {
          size: "FREE",
          quantity: 5,
        },
      ],
      price: {
        sellingPrice: 1200,
        originalPrice: 2500,
        discountPercent: 20,
      },
    },
  },
];
