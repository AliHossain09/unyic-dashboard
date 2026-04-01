import { BiCheckCircle } from "react-icons/bi";
import { RiSecurePaymentLine } from "react-icons/ri";
import { BsPatchCheck } from "react-icons/bs";
import { MdOutlineCurrencyExchange } from "react-icons/md";

const guarantees = [
  { Icon: BiCheckCircle, label: "100% Authentic Products" },
  { Icon: RiSecurePaymentLine, label: "Secure Payment" },
  { Icon: BsPatchCheck, label: "Quality Checked" },
  { Icon: MdOutlineCurrencyExchange, label: "10 Days Free Return" },
];

const FooterFeatures = () => {
  return (
    <div
      className="ui-container pt-6 text-success text-center divide-x divide-success"
      style={{
        display: "grid",
        gridTemplateColumns: `repeat(${guarantees.length}, 1fr)`,
      }}
    >
      {guarantees.map((item, index) => (
        <div key={index} className="px-2">
          <item.Icon className="mx-auto text-2xl mb-1" />
          <p className="text-xs mt-0">{item.label}</p>
        </div>
      ))}
    </div>
  );
};

export default FooterFeatures;
