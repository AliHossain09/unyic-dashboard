import PaymentMethod from "./componets/PaymentMethod";
import OrderSummary from "./componets/OrderSummary";
import ShippingAddress from "./componets/ShippingAddress";
import YourCart from "./componets/YourCart";
import CheckoutProvider from "../../contexts/checkout/CheckoutProvider";
import SelectAddressModal from "../../components/modals/SelectAddressModal";
import useCartContext from "../../contexts/cart/useCartContext";
import CheckoutSkeleton from "./componets/CheckoutSkeleton";
import NoChekoutItem from "./componets/NoChekoutItem";

const Checkout = () => {
  const { isCartLoading, cart } = useCartContext();

  if (isCartLoading) {
    return <CheckoutSkeleton />;
  }

  if (cart.length === 0) {
    return <NoChekoutItem />;
  }

  return (
    <CheckoutProvider>
      <div className="md:ui-container pt-6 pb-12 lg:py-12 bg-light-dark grid grid-cols-1 lg:grid-cols-[3fr_1.8fr] gap-8">
        <div className="space-y-6">
          <ShippingAddress />
          <PaymentMethod />
        </div>

        <div className="space-y-6">
          <YourCart />
          <OrderSummary />
        </div>
      </div>

      <SelectAddressModal />
    </CheckoutProvider>
  );
};

export default Checkout;
