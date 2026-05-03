import useModalById from "../../../hooks/useModalById";
import Modal from "../Modal";
import ProductSizeSelectorView from "./ProductSizeSelectorView";

const ProductSizeSelectorModal = () => {
  const { modalData, closeModal } = useModalById("productSizeSelectorModal");
  const product = modalData?.product;

  if (!product) {
    return null;
  }

  return (
    <Modal
      modalId="productSizeSelectorModal"
      containerClasses="w-full bottom-0"
    >
      <ProductSizeSelectorView product={product} closeModal={closeModal} />
    </Modal>
  );
};

export default ProductSizeSelectorModal;
