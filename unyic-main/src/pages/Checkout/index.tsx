import DeliveryInfoForm, {
  type DeliveryInfoFormData,
} from "./componets/DeliveryInfoForm";
import PaymentMethod from "./componets/PaymentMethod";
import OrderSummary from "./componets/OrderSummary";

const Checkout = () => {
  const handlePlaceOrder = (data: DeliveryInfoFormData) => {
    console.log(data);
  };

  return (
    <div className="md:ui-container !mt-2 lg:!mt-6 mx-auto">
      <section className="mb-6 text-center">
        <h3 className="text-2xl font-semibold">Checkout</h3>
        <p className="text-dark">{5} items</p>
      </section>

      <section className="grid grid-cols-1 lg:grid-cols-3 md:gap-8">
        <DeliveryInfoForm onSubmit={handlePlaceOrder} />

        <div className="pb-3 md:p-6 bg-light-dark space-y-6">
          <PaymentMethod />
          <OrderSummary />
        </div>
      </section>
    </div>
  );
};

export default Checkout;
