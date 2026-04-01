import { useState } from "react";
import Faqs from "../data/faqData";
import clsx from "clsx";
import AccordionItem from "../../../components/ui/AccordionItem";

const FAQSection = () => {
  const [activeTab, setActiveTab] = useState(Faqs[0].category);

  const activeFaqs =
    Faqs.find((item) => item.category === activeTab)?.faqs ?? [];

  return (
    <>
      <h3 className="uppercase pb-4 my-8 border-b-4 border-dark-deep text-xl font-semibold">
        Frequently Asked Questions
      </h3>

      {/* Tabs */}
      <div className="flex gap-4 pb-4 overflow-x-scroll md:overflow-auto">
        {Faqs.map((item) => (
          <button
            key={item.category}
            onClick={() => setActiveTab(item.category)}
            className={clsx(
              "py-2 px-4 text-nowrap",
              activeTab === item.category ? "bg-dark text-light" : "text-dark"
            )}
          >
            {item.category}
          </button>
        ))}
      </div>

      {activeFaqs.map((item, index) => (
        <AccordionItem key={index} title={item.title}>
          <div className="p-4 text-dark text-sm">{item.content}</div>
        </AccordionItem>
      ))}
    </>
  );
};

export default FAQSection;
