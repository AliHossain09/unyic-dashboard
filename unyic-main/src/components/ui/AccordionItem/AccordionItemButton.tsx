import clsx from "clsx";
import { IoIosArrowForward } from "react-icons/io";

interface AccordionItemButtonProps {
  title: string;
  onClick: () => void;
  isOpen: boolean;
}

const AccordionItemButton = ({
  title,
  onClick,
  isOpen,
}: AccordionItemButtonProps) => {
  return (
    <button
      className="w-full py-4 border-b flex justify-between items-center text-left uppercase text-sm"
      onClick={onClick}
    >
      {title}

      <IoIosArrowForward
        className={clsx(
          "lg:text-lg text-dark transition-transform duration-200",
          isOpen ? "rotate-90" : "rotate-0"
        )}
      />
    </button>
  );
};

export default AccordionItemButton;
