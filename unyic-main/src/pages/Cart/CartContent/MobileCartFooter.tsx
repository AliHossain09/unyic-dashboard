import { FaAngleDown } from "react-icons/fa";
import Button from "../../../components/ui/Button";

const MobileCartFooter = () => {
  const handleScrollToOrderSummary = () => {
    const orderSummary = document.getElementById("order-summary");
    if (orderSummary) {
      orderSummary.scrollIntoView({ behavior: "smooth" });
    }
  };

  return (
    <div className="sm:hidden w-full p-3 sticky bottom-0 left-0 bg-light flex justify-between items-center gap-8">
      <div className="space-y-px">
        <p className="font-semibold">₹ {"560,000"}</p>

        <button
          className="flex items-center gap-1 font-semibold text-sm text-nowrap"
          onClick={handleScrollToOrderSummary}
        >
          <span>View Summary</span>
          <FaAngleDown className="mt-px" />
        </button>
      </div>

      <Button href="/checkout" className="w-40 uppercase">
        Checkout
      </Button>
    </div>
  );
};

export default MobileCartFooter;
