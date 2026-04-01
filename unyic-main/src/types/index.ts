import type { PRODUCT_SIZES } from "../constants/productSizes";

export type Id = number | string;

export interface Banner {
  id: Id;
  title: string;
  link: string; // "sub-category/${slug}"
  images: {
    desktop: string;
    mobile: string;
  };
}

export interface PopularCategory {
  id: string;
  title: string;
  link: string; // "sub-category/${slug}"
  images: {
    desktop: string;
    mobile: string;
  };
}

export interface ProductImage {
  url: string;
  isDefault: 1 | 0;
}

export type ProductSize = (typeof PRODUCT_SIZES)[number];

export interface ProductSizeItem {
  size: ProductSize;
  quantity: number;
}

export interface ProductPrice {
  sellingPrice: number;
  originalPrice: number;
  discountPercent: number;
}

export interface ProductDetailsType {
  description: string;
  category: string;
  brand: string;
  collection: string;
  color: string;
  disclaimer: string;
  careInstructions: string;
}

export interface ProductDisclosureType {
  mrp: number;
  netQuantity: string; // e.g., "1 pc" or "100 ml"
  manufactureDate: string; // format "April 2025"
  countryOfOrigin: string;
}

export interface Product {
  id: Id;
  slug: string;
  name: string;
  images: ProductImage[];
  sizes: ProductSizeItem[];
  price: ProductPrice;
  details: ProductDetailsType;
  disclosure: ProductDisclosureType;
}

export interface User {
  id: string;
  name: string;
  email: string;
}

export interface CartItem {
  id: Id;
  size: ProductSize;
  quantity: number;
  product: {
    id: Id;
    name: string;
    slug: string;
    brand: string;
    images: ProductImage[];
    sizes: ProductSizeItem[];
    price: ProductPrice;
  };
}
