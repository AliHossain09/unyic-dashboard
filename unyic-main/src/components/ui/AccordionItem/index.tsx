import { useRef, useState } from "react";
import AccordionItemButton from "./AccordionItemButton";

interface AccordionItemProps {
  title: string;
  children: React.ReactNode;
  defaultOpen?: boolean;
}

const AccordionItem = ({
  title,
  children,
  defaultOpen = false,
}: AccordionItemProps) => {
  const [isOpen, setIsOpen] = useState(defaultOpen);

  const ref = useRef<HTMLDivElement>(null);

  return (
    <div>
      <AccordionItemButton
        title={title}
        isOpen={isOpen}
        onClick={() => setIsOpen((prev) => !prev)}
      />

      <div
        ref={ref}
        className="border-b -mt-px overflow-hidden transition-all duration-300 ease-in-out"
        style={{ height: isOpen ? ref.current?.scrollHeight : 0 }}
      >
        {children}
      </div>
    </div>
  );
};

export default AccordionItem;
