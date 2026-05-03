import { useCheckout } from "../../../../contexts/checkout/useCheckout";
import AddressDetails from "./AddressDetails";
import ShippingAddressHeader from "./ShippingAddressHeader";
import ShippingAddressSkeleton from "./ShippingAddressSkeleton";

const ShippingAddress = () => {
  const { isAddressListLoading } = useCheckout();

  if (isAddressListLoading) {
    return <ShippingAddressSkeleton />;
  }

  return (
    <div className="h-max p-4 py-6 md:p-6 bg-light">
      <ShippingAddressHeader />

      <AddressDetails />
    </div>
  );
};

export default ShippingAddress;
