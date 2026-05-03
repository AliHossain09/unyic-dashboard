import toast from "react-hot-toast";
import { useCreateAddressMutation } from "../../../store/features/address/addressApi";
import AddressForm, { type AddressFormData } from "../../forms/AddressForm";
import Modal from "../Modal";
import useModalById from "../../../hooks/useModalById";

const AddAddressModal = () => {
  const [createAddress, { isLoading }] = useCreateAddressMutation();
  const { closeModal } = useModalById("addAddressModal");

  const handleAddAddress = async (data: AddressFormData) => {
    try {
      await createAddress(data).unwrap();
      closeModal();
      toast.success("Address added successfully");
    } catch (error) {
      console.log("Failed to add address :", error);
      toast.error("Failed to add address");
    }
  };

  return (
    <Modal
      modalId="addAddressModal"
      containerClasses="h-screen md:h-auto w-full md:w-96 top-1/2 left-1/2 -translate-1/2"
    >
      <div className="h-15 p-4 border-b">
        <h3>Add New Address</h3>
      </div>

      <AddressForm
        action="Add"
        isFormSubmitting={isLoading}
        onSubmit={handleAddAddress}
      />
    </Modal>
  );
};

export default AddAddressModal;
