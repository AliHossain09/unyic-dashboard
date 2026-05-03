import { RiDeleteBinLine, RiLoader4Line } from "react-icons/ri";
import Button from "../../ui/Button";
import Modal from "../Modal";
import useModalById from "../../../hooks/useModalById";
import { useDeleteAddressMutation } from "../../../store/features/address/addressApi";
import toast from "react-hot-toast";

const ConfirmDeleteAddressModal = () => {
  const [deleteAddress, { isLoading }] = useDeleteAddressMutation();
  const { modalData, closeModal } = useModalById("confirmDeleteAddressModal");
  const addressId = modalData?.addressId;

  if (!addressId) {
    return null;
  }

  const handleDelete = async () => {
    if (isLoading) {
      return;
    }

    try {
      await deleteAddress(addressId).unwrap();
      toast.success("Address deleted successfully");
    } catch (error) {
      console.error("Failed to delete address :", error);
      toast.error("Failed to delete address");
    }
    finally {
      closeModal();
    }
  };

  return (
    <Modal
      modalId="confirmDeleteAddressModal"
      containerClasses="max-w-sm w-[calc(100%-24px)] p-4 top-1/2 left-1/2 -translate-1/2"
      disableScroll={true}
    >
      <div className="space-y-3">
        <h2 className="text-lg font-semibold">Remove Item</h2>

        <p className="text-dark-light text-sm">
          Are you sure you want to remove this address?
        </p>
      </div>

      {/* Action buttons */}
      <div className="mt-5 grid grid-cols-2 gap-4">
        <button
          className="px-4 py-2 bg-gray-200 rounded font-semibold"
          onClick={closeModal}
        >
          Cancel
        </button>

        <Button
          onClick={handleDelete}
          disabled={isLoading}
          className="max-w-40 flex items-center justify-center gap-2"
        >
          {isLoading ? (
            <>
              <RiLoader4Line size={20} className="animate-spin flex-none" />
              Removing...
            </>
          ) : (
            <>
              <RiDeleteBinLine size={20} className="flex-none" />
              Remove
            </>
          )}
        </Button>
      </div>
    </Modal>
  );
};

export default ConfirmDeleteAddressModal;
