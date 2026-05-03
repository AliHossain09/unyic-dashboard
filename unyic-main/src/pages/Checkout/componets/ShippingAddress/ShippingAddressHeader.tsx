import { useCheckout } from "../../../../contexts/checkout/useCheckout";
import useModalById from "../../../../hooks/useModalById";

const ShippingAddressHeader = () => {
  const { openModal } = useModalById("selectAddressModal");
  const { selectedAddress } = useCheckout();

  return (
    <div className="mb-4 flex items-center justify-between">
      <h4 className="text-xl font-bold">Shipping Address</h4>

      {selectedAddress && (
        <button
          onClick={openModal}
          className="text-primary underline underline-offset-1 font-semibold"
        >
          Change
        </button>
      )}
    </div>
  );
};

export default ShippingAddressHeader;
