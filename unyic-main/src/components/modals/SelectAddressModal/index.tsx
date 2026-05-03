import useModalById from "../../../hooks/useModalById";
import Button from "../../ui/Button";
import Modal from "../Modal";
import SelectAddressSection from "./SelectAddressSection";

const SelectAddressModal = () => {
  const { openModal: openAddAddressModal } = useModalById("addAddressModal");
  const { closeModal: closeSelectAddressModal } =
    useModalById("selectAddressModal");

  const handleAddAddress = () => {
    closeSelectAddressModal();
    openAddAddressModal();
  };

  return (
    <Modal
      modalId="selectAddressModal"
      containerClasses="h-screen md:h-auto w-full md:w-96 top-1/2 left-1/2 -translate-1/2"
      disableScroll={true}
    >
      <div className="h-15 p-4 border-b">
        <h3>Select Delivery Address</h3>
      </div>

      <div className="p-4">
        <Button variant="primary-outline" onClick={handleAddAddress}>
          Add New Address
        </Button>
      </div>

      <SelectAddressSection />
    </Modal>
  );
};

export default SelectAddressModal;
