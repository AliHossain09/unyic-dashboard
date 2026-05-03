import clsx from "clsx";
import LoadingOverlay from "../../../components/ui/LoadingOverlay";
import useCartContext from "../../../contexts/cart/useCartContext";
import CartContentSkeleton from "./CartContentSkeleton";
import CartItemsSection from "./CartItemsSection";
import EmptyCart from "./EmptyCart";
import MobileCartFooter from "./MobileCartFooter";
import OrderSummary from "./OrderSummary";

const CartContent = () => {
  const { cart, isCartLoading, isCartRefetching } = useCartContext();

  if (isCartLoading) {
    return <CartContentSkeleton />;
  }

  if (cart.length === 0) {
    return <EmptyCart />;
  }

  return (
    <>
      {isCartRefetching && <LoadingOverlay />}

      <div
        className={clsx(
          "lg:max-w-237.5 lg:mx-auto lg:my-8 py-3 lg:p-6 bg-light-dark relative",
          "grid grid-cols-1 gap-4 lg:grid-cols-[1fr_300px] lg:gap-8",
        )}
      >
        <CartItemsSection />
        <OrderSummary />
        <MobileCartFooter />
      </div>
    </>
  );
};

export default CartContent;
