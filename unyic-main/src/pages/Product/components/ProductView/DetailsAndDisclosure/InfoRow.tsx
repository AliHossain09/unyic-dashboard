interface InfoRowProps {
  label: string;
  value: string | number | React.ReactNode;
}

const InfoRow = ({ label, value }: InfoRowProps) => (
  <div className="flex gap-4">
    <span className="w-28 flex-none text-dark-light text-sm">{label}</span>
    <span className="font-semibold text-sm">{value}</span>
  </div>
);

export default InfoRow;
