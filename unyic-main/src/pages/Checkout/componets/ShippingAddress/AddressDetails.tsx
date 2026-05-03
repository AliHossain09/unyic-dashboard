import NoSelectedAddressFound from "./NoSelectedAddressFound";
import AddressTypeIcon from "../../../../components/ui/AddressTypeIcon";
import { useCheckout } from "../../../../contexts/checkout/useCheckout";

const AddressDetails = () => {
  const { selectedAddress } = useCheckout();

  if (!selectedAddress) {
    return <NoSelectedAddressFound />;
  }

  const { name, phone, email, address, addressType, isDefault } =
    selectedAddress || {};

  const fields = [
    { label: "Name", value: name },
    { label: "Address", value: address },
    { label: "Phone", value: phone },
    { label: "Email", value: email },
  ];

  return (
    <div className="h-48">
      <div className="mb-4 flex gap-3 items-center text-sm font-semibold">
        <span className="px-4 py-0.75 rounded bg-dark-light/10 capitalize flex items-center gap-2">
          <AddressTypeIcon addressType={addressType} />
          {addressType}
        </span>

        {isDefault && (
          <span className="px-4 py-0.75 rounded bg-primary/20 text-primary-dark">
            Default
          </span>
        )}
      </div>

      <div className="ps-1.5 text-sm space-y-4 font-medium">
        {fields.map((item) => (
          <div key={item.label} className="flex items-center">
            <p className="w-24 flex-none text-xs font-semibold uppercase text-dark-light">
              {item.label}
            </p>
            <p>{item.value}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default AddressDetails;
