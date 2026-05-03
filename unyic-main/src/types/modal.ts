import type { Address, CartItem, Id } from ".";
import type { Product } from "./product";

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

  addAddressModal: ModalState;
  updateAddressModal: ModalState<{
    address: Address;
  } | null>;
  selectAddressModal: ModalState;

  confirmCartDeleteModal: ModalState<{
    cartItem: CartItem;
  } | null>;

  confirmDeleteAddressModal: ModalState<{
    addressId: Id;
  } | null>;
  confirmLogoutModal: ModalState;
}

export type ModalId = keyof ModalsState;
