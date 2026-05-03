import OrderSummarySkeleton from "./OrderSummary/OrderSummarySkeleton";
import PaymentMethodSkeleton from "./PaymentMethod/PaymentMethodSkeleton";
import ShippingAddressSkeleton from "./ShippingAddress/ShippingAddressSkeleton";
import YourCartSkeleton from "./YourCart/YourCartSkeleton";

const CheckoutSkeleton = () => {
  return (
    <div className="md:ui-container pt-6 pb-12 lg:py-12 bg-light-dark grid grid-cols-1 lg:grid-cols-[3fr_1.8fr] gap-8">
      <div className="space-y-6">
        <ShippingAddressSkeleton />
        <PaymentMethodSkeleton />
      </div>

      <div className="space-y-6">
        <YourCartSkeleton />
        <OrderSummarySkeleton />
      </div>
    </div>
  );
};

export default CheckoutSkeleton;
