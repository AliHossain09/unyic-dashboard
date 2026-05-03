import { useEffect, useState } from "react";
import { useGetAddressesQuery } from "../../store/features/address/addressApi";
import { CheckoutContext } from "./checkoutContext";
import type { Address } from "../../types";

interface CheckoutProviderProps {
  children: React.ReactNode;
}

const CheckoutProvider = ({ children }: CheckoutProviderProps) => {
  const {
    data: addressList = [],
    isLoading,
    isUninitialized,
  } = useGetAddressesQuery();

  const [selectedAddress, setSelectedAddress] = useState<Address | null>(null);

  useEffect(() => {
    if (addressList.length === 0) {
      return;
    }

    const selectedAddress =
      addressList.find((addr) => addr.isSelected) ||
      addressList.find((addr) => addr.isDefault) ||
      addressList[0];

    // eslint-disable-next-line react-hooks/set-state-in-effect
    setSelectedAddress(selectedAddress);
  }, [addressList]);

  return (
    <CheckoutContext.Provider
      value={{
        addressList,
        isAddressListLoading: isLoading || isUninitialized,
        selectedAddress,
      }}
    >
      {children}
    </CheckoutContext.Provider>
  );
};

export default CheckoutProvider;
