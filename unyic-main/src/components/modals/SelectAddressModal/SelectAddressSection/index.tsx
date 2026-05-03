import SelectAddressList from "./SelectAddressList";
import { useState } from "react";
import { useCheckout } from "../../../../contexts/checkout/useCheckout";
import SelectAddressFooter from "./SelectAddressFooter";
import type { Id } from "../../../../types";

const SelectAddressSection = () => {
  const { selectedAddress } = useCheckout();

  const [selectedAddressId, setSelectedAddressId] = useState<Id | null>(
    selectedAddress?.id ?? null,
  );

  return (
    <>
      <SelectAddressList
        selectedAddressId={selectedAddressId}
        onAddressSelect={setSelectedAddressId}
      />

      <SelectAddressFooter selectedAddressId={selectedAddressId} />
    </>
  );
};

export default SelectAddressSection;
