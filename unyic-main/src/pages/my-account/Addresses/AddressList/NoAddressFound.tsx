import { RiMapPinLine } from "react-icons/ri";

const NoAddressFound = () => {
  return (
    <div className="mt-16 flex flex-col items-center justify-center py-10 text-center text-dark-light">
      <RiMapPinLine className="text-4xl mb-3 opacity-70" />

      <h3 className="text-lg font-semibold">No Address Found</h3>

      <p className="text-sm mt-1">You haven't added any address yet.</p>
    </div>
  );
};

export default NoAddressFound;
