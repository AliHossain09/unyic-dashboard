import { createContext } from "react";
import type { Address } from "../../types";

type CheckoutContextType = {
  addressList: Address[];
  isAddressListLoading: boolean;
  selectedAddress: Address | null;
};

export const CheckoutContext = createContext<CheckoutContextType | null>(null);
