import { Link } from "react-router";
import useScreenSize from "../../../../../../hooks/useScreenSize";
import Button from "../../../../../ui/Button";
import MiniCartCard from "./MiniCartCard";
import useCartContext from "../../../../../../contexts/cart/useCartContext";

const MiniCart = () => {
  const { isDesktopScreen } = useScreenSize();
  const { cart, cartTotal } = useCartContext();

  if (!isDesktopScreen || cart.length === 0) {
    return null;
  }

  return (
    <div className="hidden group-hover:block absolute z-50 top-8 -right-2">
      <div className="w-80 p-3 border bg-light text-base relative">
        <ul
          className="max-h-96 overflow-y-auto divide-y"
          style={{ scrollbarWidth: "thin" }}
        >
          {cart.map((item) => (
            <MiniCartCard key={item.id} item={item} />
          ))}
        </ul>

        <div className="w-full py-2 space-y-4">
          <p className="pt-2 border-t flex justify-center gap-1 font-semibold text-lg">
            <span>Total payable:</span>
            <span>₹ {cartTotal}</span>
          </p>

          <Button href="/checkout" className="uppercase">
            Checkout
          </Button>
        </div>

        {/* Extra hover area to keep dropdown open */}
        <Link to={"/cart"} className="size-8 absolute -top-8 right-0" />
        {/* Pointer */}
        <div className="size-3 border border-e-0 border-b-0 rotate-45 absolute -top-1.75 right-3 bg-light" />
      </div>
    </div>
  );
};

export default MiniCart;
