import { RiDeleteBinLine } from "react-icons/ri";
import useModalById from "../../../hooks/useModalById";
import { useRemoveCartItemMutation } from "../../../store/features/cart/cartApi";
import LoadingOverlay from "../../ui/LoadingOverlay";
import Modal from "../Modal";
import Button from "../../ui/Button";
import { getDefaultImageUrl } from "../../../utlis/product";

const ConfirmCartDeleteModal = () => {
  const { modalData, closeModal } = useModalById("confirmCartDeleteModal");
  const [removeCartItem, { isLoading, error }] = useRemoveCartItemMutation();

  // Show loading overlay while mutation is in progress
  if (isLoading) {
    return <LoadingOverlay />;
  }

  if (error) {
    console.log("Error removing cart item:", error);
  }

  const cartItem = modalData?.cartItem;

  // Exit early if no cart item is provided
  if (!cartItem) {
    return null;
  }

  const handleRemove = () => {
    removeCartItem(cartItem?.id);
    closeModal();
  };

  const imageUrl = getDefaultImageUrl(cartItem?.product?.images || []);

  return (
    <Modal
      modalId="confirmCartDeleteModal"
      containerClasses="p-4 max-w-sm w-full top-1/2 left-1/2 -translate-1/2"
    >
      <div className="flex gap-4">
        <figure className="w-20 product-image-ratio bg-gray-200">
          <img
            src={imageUrl}
            alt="Product Image"
            className="size-full object-cover"
          />
        </figure>

        <div className="space-y-3">
          <h2 className="text-lg font-semibold">Remove Item</h2>

          <p className="text-dark-light text-sm">
            Are you sure you want to remove this item from your cart?
          </p>
        </div>
      </div>

      {/* Action buttons */}
      <div className="mt-4 grid grid-cols-2 gap-4">
        <button
          className="px-4 py-2 bg-gray-200 rounded font-semibold"
          onClick={closeModal}
        >
          Cancel
        </button>

        <Button
          onClick={handleRemove}
          className="max-w-40 flex items-center justify-center gap-2"
        >
          <RiDeleteBinLine size={20} className="flex-none" /> Remove
        </Button>
      </div>
    </Modal>
  );
};

export default ConfirmCartDeleteModal;
