import clsx from "clsx";
import { useState } from "react";
import { IoIosArrowForward } from "react-icons/io";

interface FooterAccordionItemProps {
  item: {
    title: string;
    links: {
      name: string;
      href: string;
    }[];
  };
}

const FooterAccordionItem = ({ item }: FooterAccordionItemProps) => {
  const [isOpen, setIsOpen] = useState(false);

  const { title, links } = item || {};

  return (
    <div className="ui-container !mt-0 py-2">
      <button
        onClick={() => setIsOpen((prev) => !prev)}
        className="w-full font-semibold flex items-center justify-between"
      >
        <span>{title}</span>

        <IoIosArrowForward
          className={clsx(
            "transition-transform duration-300",
            isOpen ? "rotate-90" : "rotate-0"
          )}
        />
      </button>

      <ul
        className={clsx(
          "mt-2 list-none transition-all duration-300 overflow-hidden space-y-2",
          isOpen ? "max-h-[1000px]" : "max-h-0"
        )}
      >
        {links.map(({ name, href }) => (
          <li key={name} className="flex items-center gap-2">
            <IoIosArrowForward className="text-gray-400" />
            <a href={href}>{name}</a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default FooterAccordionItem;
