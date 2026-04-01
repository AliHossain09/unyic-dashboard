import clsx from "clsx";
import CartItemsSectionSkeleton from "./CartItemsSection/CartItemsSectionSkeleton";
import OrderSummarySkeleton from "./OrderSummary/OrderSummarySkleton";

const CartContentSkeleton = () => {
  return (
    <div
      className={clsx(
        "lg:max-w-[950px] lg:mx-auto lg:mt-6 py-3 lg:p-6 bg-light-dark relative",
        "grid grid-cols-1 gap-4 lg:grid-cols-[1fr_300px] lg:gap-8"
      )}
    >
      <CartItemsSectionSkeleton />
      <OrderSummarySkeleton />
    </div>
  );
};

export default CartContentSkeleton;
