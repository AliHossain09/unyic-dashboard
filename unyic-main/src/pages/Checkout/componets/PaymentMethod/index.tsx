import { FaCheckCircle } from "react-icons/fa";

const PaymentMethod = () => {
  return (
    <div className="p-4 py-6 md:p-6 bg-light">
      <h4 className="mb-4 text-lg font-bold">Payment Method</h4>

      <div className="w-full px-4 py-2 border rounded text-dark relative">
        <span>Cash On Delivery</span>
        <FaCheckCircle className="absolute right-3 top-1/2 -translate-y-1/2" />
      </div>
    </div>
  );
};

export default PaymentMethod;
