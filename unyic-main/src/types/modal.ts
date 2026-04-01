import type { CartItem, Product } from ".";

export type AuthActiveTab = "login" | "signup";

export type ModalState<Data = null> = {
  isOpen: boolean;
  data: Data;
};

export interface ModalsState {
  authModal: ModalState<{ activeTab: AuthActiveTab }>;
  forgotPasswordModal: ModalState;
  productSizeSelectorModal: ModalState<{
    product: Product;
  } | null>;
  confirmCartDeleteModal: ModalState<{
    cartItem: CartItem;
  } | null>;
}

export type ModalId = keyof ModalsState;
