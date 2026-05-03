import CartCardSkeleton from "./CartCard/CartCardSkeleton";

const CartItemsSectionSkeleton = () => {
  return (
    <div className="space-y-3">
      <div className="h-13 p-3 bg-light">
        <div className="h-7 w-46 rounded-md bg-gray-200 animate-pulse" />
      </div>

      {[...Array(2)].map((_, index) => (
        <CartCardSkeleton key={index} />
      ))}
    </div>
  );
};

export default CartItemsSectionSkeleton;
