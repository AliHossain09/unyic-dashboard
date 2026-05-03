import { useCheckout } from "../../../../../contexts/checkout/useCheckout";
import type { Id } from "../../../../../types";
import SelectAddressItem from "./SelectAddressItem";

interface SelectAddressListProps {
  selectedAddressId: Id | null;
  onAddressSelect: (id: Id) => void;
}

const SelectAddressList = ({
  selectedAddressId,
  onAddressSelect,
}: SelectAddressListProps) => {
  const { addressList } = useCheckout();

  if (addressList.length === 0) {
    return null;
  }

  return (
    <div className="h-[calc(100dvh-194px)] overflow-y-auto px-4 pb-4 space-y-4">
      {addressList.map((item) => (
        <SelectAddressItem
          key={item.id}
          item={item}
          isSelected={selectedAddressId === item.id}
          onSelect={() => onAddressSelect(item.id)}
        />
      ))}
    </div>
  );
};

export default SelectAddressList;
