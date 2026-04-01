import clsx from "clsx";
import { MdKeyboardArrowRight } from "react-icons/md";

interface NavigationButtonProps {
  position: "next" | "prev";
  onClick?: () => void;
  disabled: boolean;
}

const NavigationButton = ({
  position,
  onClick,
  disabled,
}: NavigationButtonProps) => {
  return (
    <button
      onClick={onClick}
      disabled={disabled}
      aria-label={position === "prev" ? "Previous slide" : "Next slide"}
      className={clsx(
        "size-7 bg-white/50 grid place-items-center",
        "absolute z-10 top-1/2 -translate-y-1/2",
        {
          "left-2": position === "prev",
          "right-2": position === "next",
        },
        "disabled:hidden"
      )}
    >
      <MdKeyboardArrowRight
        size={16}
        className={clsx(position === "prev" && "rotate-180")}
      />
    </button>
  );
};

export default NavigationButton;
