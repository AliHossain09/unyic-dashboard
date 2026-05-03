import { LuMapPinPlus } from "react-icons/lu";
import useModalById from "../../../../hooks/useModalById";

const NoSelectedAddressFound = () => {
  const { openModal } = useModalById("addAddressModal");

  return (
    <button
      onClick={openModal}
      className="h-48 w-full grid place-items-center border border-dashed rounded-2xl"
    >
      <div className="text-center text-dark-light">
        <LuMapPinPlus size={32} className="mb-3 mx-auto" />
        <p className="text-sm">You have not add any address yet.</p>
      </div>
    </button>
  );
};

export default NoSelectedAddressFound;
