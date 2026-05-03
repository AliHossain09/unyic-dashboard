import { FaPlus } from "react-icons/fa";
import Button from "../../../components/ui/Button";
import useModalById from "../../../hooks/useModalById";
import AddressList from "./AddressList";

const Addresses = () => {
  const { openModal } = useModalById("addAddressModal");

  return (
    <>
      <div className="mb-6 flex items-center justify-between">
        <h3 className="text-xl sm:text-2xl font-semibold">My addresses</h3>

        <Button
          onClick={openModal}
          className="w-max px-3 flex items-center gap-2 text-xs"
        >
          <FaPlus />
          <span className="uppercase sm:text-sm">Add An Address</span>
        </Button>
      </div>

      <AddressList />
    </>
  );
};

export default Addresses;
