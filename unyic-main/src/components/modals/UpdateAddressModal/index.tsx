import toast from "react-hot-toast";
import useModalById from "../../../hooks/useModalById";
import { useUpdateAddressMutation } from "../../../store/features/address/addressApi";
import type { AddressFormData } from "../../forms/AddressForm";
import AddressForm from "../../forms/AddressForm";
import Modal from "../Modal";

const UpdateAddressModal = () => {
  const [updateAddress, { isLoading }] = useUpdateAddressMutation();
  const { modalData, closeModal } = useModalById("updateAddressModal");
  const address = modalData?.address;

  if (!address) {
    return null;
  }

  const handleUpdateAddress = async (data: AddressFormData) => {
    try {
      await updateAddress({ id: address.id, data }).unwrap();
      closeModal();
      toast.success("Address updated successfully");
    } catch (error) {
      console.log("Failed to update address :", error);
      toast.error("Failed to update address");
    }
  };

  return (
    <Modal
      modalId="updateAddressModal"
      containerClasses="h-screen md:h-auto w-full md:w-96 top-1/2 left-1/2 -translate-1/2"
    >
      <div className="h-15 p-4 border-b">
        <h3>Update Address</h3>
      </div>

      <AddressForm
        action="Edit"
        isFormSubmitting={isLoading}
        defaultValues={{
          name: address.name,
          address: address.address,
          addressType: address.addressType,
          phone: address.phone,
          email: address.email,
          isDefault: address.isDefault,
          isSelected: address.isSelected,
        }}
        onSubmit={handleUpdateAddress}
      />
    </Modal>
  );
};

export default UpdateAddressModal;
