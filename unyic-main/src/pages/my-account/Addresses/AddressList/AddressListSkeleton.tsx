import AddressCardSkeleton from "./AddressCard/AddressCardSkeleton";

const AddressListSkeleton = () => {
  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      {[...Array(2)].map((_, index) => (
        <AddressCardSkeleton key={index} />
      ))}
    </div>
  );
};

export default AddressListSkeleton;
