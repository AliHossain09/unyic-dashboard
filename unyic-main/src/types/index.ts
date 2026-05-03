import type {
  ProductImage,
  ProductPrice,
  ProductSize,
  ProductSizeItem,
} from "./product";

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
  id: Id;
  title: string;
  link: string; // "sub-category/${slug}"
  images: {
    desktop: string;
    mobile: string;
  };
}

export interface LatestCategory {
  id: Id;
  slug: string;
  name: string;
  image: string;
}

export interface FeaturedCollection {
  id: Id;
  slug: string;
  name: string;
  image: string;
  brand: string;
  short_description: string;
}

export interface SpotlightBrand {
  id: Id;
  slug: string;
  name: string;
  image: string;
}

export interface User {
  id: Id;
  name: string;
  email: string;
  phone: string;
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

export interface Address {
  id: Id;
  name: string;
  email: string;
  phone: string;
  address: string;
  addressType: string;
  isDefault: boolean;
  isSelected: boolean;
}
