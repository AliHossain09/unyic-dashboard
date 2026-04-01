import ConfirmCartDeleteModal from "../../../../components/modals/ConfirmCartDeleteModal";
import useCartContext from "../../../../contexts/cart/useCartContext";
import CartCard from "./CartCard";

const CartItemsSection = () => {
  const { cart } = useCartContext();

  return (
    <>
      <div className="space-y-3">
        <div className="h-13 p-3 bg-light">
          <h3 className="text-xl">
            <span className="font-semibold">Shopping Bag</span>{" "}
            <span className="text-dark-light">({cart.length} Items)</span>
          </h3>
        </div>

        {cart?.map((cartItem) => (
          <CartCard key={cartItem.id} cartItem={cartItem} />
        ))}
      </div>

      <ConfirmCartDeleteModal />
    </>
  );
};

export default CartItemsSection;
