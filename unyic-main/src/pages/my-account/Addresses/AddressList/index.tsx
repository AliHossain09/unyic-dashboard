import { useGetAddressesQuery } from "../../../../store/features/address/addressApi";
import AddressCard from "./AddressCard";
import AddressListSkeleton from "./AddressListSkeleton";
import NoAddressFound from "./NoAddressFound";

const AddressList = () => {
  const {
    data: addresses,
    isLoading,
  } = useGetAddressesQuery();

  if (isLoading) {
    return <AddressListSkeleton />;
  }

  if (!addresses || addresses.length === 0) {
    return <NoAddressFound />;
  }

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      {addresses.map((address) => (
        <AddressCard key={address.id} address={address} />
      ))}
    </div>
  );
};

export default AddressList;
